Development of an Online Scholarship Application System for St. Cecilia's College Cebu, Inc.

Description  
This project aims to develop an Online Scholarship Application System for St. Cecilia's College Cebu, Inc. The system is designed to provide a user-friendly platform for managing educational scholarships for college students. It simplifies the application process, reduces errors, and improves data security. By shifting from a manual to a digital system, the project enhances the workflow for administrators and scholarship officers, improving the overall efficiency and effectiveness of scholarship management.

Table of Contents  
\- (installation)  
\- (usage)  
\- (contributing)  
\- (license)

Installation  
To set up the Online Scholarship Application System locally, follow these steps:

1\. Clone the Repository  
    
git clone https://github.com/kaylexd/edufund

2\. Navigate to the Project Directory  
    
cd scholarship-system

3\. Install Dependencies  
   Ensure you have PHP and MySQL installed. Then, install the necessary dependencies:  
    
composer install  
npm install

4\. Set Up the Database  
   \- Create a new MySQL database.  
   \- Import the provided SQL file to set up the database schema:  
      
mysql \-u username \-p database\_name \< database/scholarship.sql

5\. Configure the Environment  
   \- Copy the .env.example file to .env and update the database credentials.

6\. Run the Application  
    
php artisan serve

7\. Access the Application  
   Visit http://localhost:8000 in your web browser.

Usage

Once the application is set up, users can:

\- Students: Register, apply for scholarships, track application status, and receive updates via email.  
\- Scholarship Officers: Manage applications, review and approve submissions, and communicate with students.  
\- Administrators: Oversee the entire system, manage user accounts, and generate reports.

Contributing

We welcome contributions from the community. To contribute:

1\. Fork the repository.  
2\. Create a new branch for your feature or bug fix.  
3\. Commit your changes.  
4\. Push your branch and submit a pull request.

Please adhere to the project's coding standards and guidelines.


For any questions or further information, please contact ONLINE SCHOLARSHIP SYSTEM(mailto:datadynamo@gmail.com)."# scholarship" 
