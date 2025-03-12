<?php

namespace App\Domain\GeneratePDF;

use App\Domain\AbstractService;
use App\Domain\RequestInterface;
use App\Domain\ServiceInterface;
use App\Provider\BauBuddy\UseCase\SelectTasks\SelectTasksUseCase;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class Service extends AbstractService implements ServiceInterface
{
    public function __construct(
        protected SelectTasksUseCase $selectTasksUseCase,
        protected Pdf                $pdfGenerator,
        protected Environment        $twig
    )
    {
    }

    public function validate(RequestInterface|RequestDTO $request): ?Response
    {
        $errors = $this->validator->validate($request);

        if (count($errors) > 0) {
            return new Response((string)$errors, Response::HTTP_BAD_REQUEST);
        }

        return null;
    }

    public function handle(RequestInterface|RequestDTO $request): Response
    {
        $dto = $this->selectTasksUseCase->getTasks($request->username, $request->password);

        $pdf = $this->pdfGenerator->getOutputFromHtml(
            $this->twig->render('tasks/list.html.twig', ['dto' => $dto])
        );

        return new PdfResponse($pdf, 'tasks.pdf');
    }
}