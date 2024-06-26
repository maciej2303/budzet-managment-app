# Web Application for Home Budget Management

## Overview

This repository contains the source code for a web application designed to manage home budgets. The application was developed as part of my engineering thesis at the Academy of Kalisz under the supervision of Dr. Piotr Knychała. The project demonstrates my proficiency in full-stack development, specifically using PHP, JavaScript, HTML, CSS (Tailwind), and the Laravel framework.

## Project Goals

The primary objective of this project was to create a comprehensive tool that allows families to effectively manage their shared budget. Key features include:

- Recording income and expenses
- Categorizing transactions
- Storing digital copies of receipts and invoices
- Generating detailed reports and forecasts
- Setting spending thresholds with alerts
- Enabling shared access for multiple users within a household

## Technology Stack

- **Backend:** PHP 7.4, Laravel Framework
- **Frontend:** HTML, Tailwind CSS, JavaScript
- **Database:** MySQL
- **Tools:** Visual Studio Code, phpMyAdmin, XAMPP, Git

## Architecture

The application is built using the MVC (Model-View-Controller) design pattern, which ensures a clean separation of concerns, making the codebase modular, maintainable, and scalable.

## Key Features

1. **User Management:** Register, login, edit profile, and delete account functionalities.
2. **Budget Management:** Add, edit, and delete income and expense entries. Assign categories to transactions for better organization and reporting.
3. **Receipt Documentation:** Upload and store images of receipts and invoices linked to respective transactions.
4. **Shared Budgets:** Multiple users can manage a common budget, with visibility into each member's contributions and expenditures.
5. **Automated Reports:** Generate comprehensive reports and visual charts to analyze spending patterns and budget allocations.
6. **Spending Thresholds:** Set monthly spending limits and receive alerts when nearing these thresholds.
7. **Recurring Transactions:** Schedule and manage recurring income and expense entries.

## Testing

The application includes both manual and automated tests to ensure reliability and robustness:

- **Manual Testing:** Comprehensive manual testing for all critical functionalities.
- **Automated Testing:** PHPUnit for unit and integration tests covering user authentication, budget operations, and report generation.


## How to Run the Project

Follow these steps to set up and run the project locally:

### Prerequisites

Ensure you have the following installed on your machine:
- PHP 7.4
- Composer
- Node.js and npm
- MySQL
- Git

### Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/budget-management-app.git
   ```
2. **Navigate to the project directory:**
   ```sh
   cd budget-management-app
   ```
3. **Install PHP dependencies:**
   ```sh
   composer install
   ```
4. **Install JavaScript dependencies:**
   ```sh
   npm install
   ```

### Database Setup

1. **Create a new MySQL database:**
   ```sql
   CREATE DATABASE budget_management;
   ```

2. **Copy the `.env.example` file to `.env` and update the database configuration:**
   ```sh
   cp .env.example .env
   ```

   Update the following lines in the `.env` file with your database details:
   ```env
   DB_DATABASE=budget_management
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

3. **Run the database migrations:**
   ```sh
   php artisan migrate
   ```

4. **Seed the database with initial data (optional):**
   ```sh
   php artisan db:seed
   ```

### Running the Application

1. **Start the PHP development server:**
   ```sh
   php artisan serve
   ```

2. **Compile the front-end assets:**
   ```sh
   npm run dev
   ```

3. **Open your web browser and navigate to:**
   ```
   http://localhost:8000
   ```

### Additional Commands

- **To run automated tests:**
  ```sh
  php artisan test
  ```

- **To build assets for production:**
  ```sh
  npm run production
  ```

### Troubleshooting

- Ensure your `.env` file is correctly configured.
- If you encounter issues with the PHP or MySQL versions, consider using tools like XAMPP or Laravel Valet to manage your development environment.
- Check the Laravel and npm documentation for additional support and configuration options.

With these steps, you should have the application up and running on your local machine. If you encounter any issues, feel free to reach out for support.

## Conclusion

This project showcases my ability to design and implement a full-featured web application from scratch, integrating front-end and back-end technologies, ensuring security through password hashing, and providing a responsive user interface. The comprehensive documentation and well-structured codebase highlight my commitment to best practices in software development.
