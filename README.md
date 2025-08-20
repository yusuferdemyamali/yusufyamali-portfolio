# Personal Portfolio Website

A Laravel application developed to create a personal portfolio website. This website showcases information about me, my professional experience, education, projects, and a blog.

## Features

- **About Me:** Personal information and a link to my CV.
- **Experience:** A chronological list of my work experience.
- **Education:** A chronological list of my educational background.
- **Projects:** Details of my past projects.
- **Blog:** A list of my recent blog posts with a link to view all posts.
- **Contact:** My contact information and social media links.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- A database server (e.g., MySQL)
- Filament PHP 3.0.0

### Installation

Follow these steps to get a local copy of the project up and running.

1.  Clone the repository:
    ```sh
    git clone [https://github.com/yusuferdemyamali/portfolio-web.git](https://github.com/yusuferdemyamali/portfolio-web.git)
    ```

2.  Navigate to the project directory:
    ```sh
    cd portfolio-web
    ```

3.  Install the required dependencies:
    ```sh
    composer install
    ```

4.  Create and configure your `.env` file:
    ```sh
    cp .env.example .env
    # Edit the .env file with your database configuration
    ```

5.  Generate the application key:
    ```sh
    php artisan key:generate
    ```

6.  Run database migrations and seed the database:
    ```sh
    php artisan migrate --seed
    ```

7.  Start the local development server:
    ```sh
    php artisan serve
    ```

You can now access the application at `http://127.0.0.1:8000`.

## Contribution

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1.  Fork the Project
2.  Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push to the Branch (`git push origin feature/AmazingFeature`)
5.  Open a Pull Request

---

**Built With**

* [Laravel](https://laravel.com/) - The PHP Framework for Web Artisans
* [Filament](https://filamentphp.com/) - The elegant TALL stack admin panel for Laravel

---

**License**

Distributed under the MIT License. See `LICENSE` for more information.

---

**Contact**

* **Yusuf Erdem Yamalı** - yusuferdem.dev@gmail.com
* Project Link: https://yusufyamali.me
