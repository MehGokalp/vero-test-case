<?php

namespace App\Tests\Domain\GeneratePDF;

use App\Domain\GeneratePDF\RequestDTO;
use App\Domain\GeneratePDF\Service;
use App\Provider\BauBuddy\UseCase\SelectTasks\ResponseDTO;
use App\Provider\BauBuddy\UseCase\SelectTasks\SelectTasksUseCase;
use App\Provider\BauBuddy\UseCase\SelectTasks\TaskDTO;
use Knp\Snappy\Pdf;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Twig\Environment;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ServiceTest extends TestCase
{
    private $selectTasksUseCase;
    private $pdfGenerator;
    private $twig;
    private $validator;
    private $service;

    protected function setUp(): void
    {
        $this->selectTasksUseCase = $this->createMock(SelectTasksUseCase::class);
        $this->pdfGenerator = $this->createMock(Pdf::class);
        $this->twig = $this->createMock(Environment::class);
        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->service = new Service(
            $this->selectTasksUseCase,
            $this->pdfGenerator,
            $this->twig
        );

        $this->service->setValidator($this->validator);
    }

    public function testValidateWithErrors()
    {
        $request = new RequestDTO();
        $errList = new ConstraintViolationList();
        $errList->add($this->createMock(ConstraintViolation::class));
        $this->validator->method('validate')->willReturn($errList);

        $response = $this->service->validate($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testValidateWithoutErrors()
    {
        $request = new RequestDTO();
        $request->username = 'test';
        $request->password = 'test';
        $errList = new ConstraintViolationList();
        $this->validator->method('validate')->willReturn($errList);

        $response = $this->service->validate($request);

        $this->assertNull($response);
    }

    public function testHandle()
    {
        $request = new RequestDTO();
        $request->username = 'testuser';
        $request->password = 'testpass';

        $dto = new ResponseDTO([
            new TaskDTO('test', 'test', 'test', 'test')
        ]); // Replace with actual DTO class if available
        $this->selectTasksUseCase->method('getTasks')->willReturn($dto);
        $this->twig->method('render')->willReturn('<html></html>');
        $this->pdfGenerator->method('getOutputFromHtml')->willReturn('pdfcontent');

        $response = $this->service->handle($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('application/pdf', $response->headers->get('Content-Type'));
        $this->assertEquals('pdfcontent', $response->getContent());
    }
}