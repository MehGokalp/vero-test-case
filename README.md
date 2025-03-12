Hello and welcome, dear developer!

This repository is a playground for your submission which should use PHP and HTML/CSS.

Before you get started, be sure to click the `Use this template` button to create a new repository where you will commit and push your code regularly. Once completed, send us the link to your repository.

Good luck, and have fun ☘️

# Task Overview

Your primary objective is to build a web service that receives a `username` and `password` via a GET request. Upon successful authentication and data retrieval, it should generate a PDF document from dynamically created HTML, using `wkhtmltopdf` to perform the HTML-to-PDF conversion.  The PDF should contain task data fetched from an API.

## Requirements

1.  **Docker Environment Setup:**
    *   Create a `Dockerfile` to containerize your PHP application.
    *   Ensure your Dockerfile includes the installation of `wkhtmltopdf`. This tool is essential for converting HTML to PDF within your Docker container.

2.  **GET Request Handling & API Interaction:**
    *   Implement a PHP script that accepts `username` and `password` as **query parameters** in a GET request (e.g., `/service.php?username=your_username&password=your_password`).
    *   **Authentication & Authorization:**
        *   Use the provided `username` and `password` to obtain an authorization token from our API. Refer to the "Authorization" section below for detailed instructions.
        *   Once you have the access token, use it to make an authorized GET request to `https://api.baubuddy.de/dev/index.php/v1/tasks/select` to download task data in JSON format.

3.  **HTML Generation & Data Display:**
    *   Dynamically generate HTML to present the downloaded task data.
    *   Display the following fields for each task: `task`, `title`, `description`, and `colorCode`.
    *   Visually represent the `colorCode`.  For example, you could use a colored box, background, or text to reflect the `colorCode` associated with each task.

4.  **PDF Generation and Download:**
    *   Utilize `wkhtmltopdf` within your PHP application to convert the dynamically generated HTML into a PDF document.
    *   Configure your PHP script to send the generated PDF as a downloadable response to the client's browser.  The user should be prompted to save the PDF file.

# Authorization

It is mandatory that your requests to the API are authorized. You can find the required request below:

This is how it looks in `curl`:

```bash
curl --request POST \
  --url https://api.baubuddy.de/index.php/login \
  --header 'Authorization: Basic QVBJX0V4cGxvcmVyOjEyMzQ1NmlzQUxhbWVQYXNz' \
  --header 'Content-Type: application/json' \
  --data '{
        "username":"365",
        "password":"1"
}'
```

The response will contain a JSON object, having the access token in `json["oauth"]["access_token"]`. For all subsequent calls this has to be added to the request headers as `Authorization: Bearer {access_token}`.
