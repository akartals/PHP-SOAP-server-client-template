# PHP_SOAP_Service

A PHP-based SOAP web service template designed for secure data management and flexible query handling. This project enables user authentication, database querying, and XML response formatting, making it suitable for a range of applications requiring structured data exchange with external systems.

## Features

- **SOAP Web Service**: Built on PHP's SOAP server functionality, adhering to WSDL for structured communication.
- **User Authentication**: Login through database validation.
- **Database Querying**: Executes parameterized SQL queries to prevent SQL injection attacks.
- **XML Response Formatting**: Outputs data in an XML structure for easy integration with consuming applications.

## Installation

1. Clone this repository to your local server environment:
    ```bash
    git clone https://github.com/akartals/PHP-SOAP-server-client-template.git
    ```
2. Navigate to the project directory:
    ```bash
    cd PHP-SOAP-server-client-template
    ```

3. Configure the database:
    - Import the soapwdsl.sql to your server.

4. Update `./helpers/database.php` with your database connection details.

5. Place `test.wsdl` in the root directory.

6. **Update the Server URL**:
   - Locate any instances of `http://localhost/soaptest` in files and replace them with your server’s URL (e.g., `https://yourserver.com/soaptest`).

## Usage

You can use the client.php for retrieving data from server.

### Example SOAP Request

```xml
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:koc="Kocatepe">
   <soapenv:Header/>
   <soapenv:Body>
      <koc:GetBookList>
         <request>
            <username>akartals</username>
            <password>123456</password>
            <type>roman</type>
         </request>
      </koc:GetBookList>
   </soapenv:Body>
</soapenv:Envelope>
```


## TODO
- Implement WSS for encrypted authentication
- Hash user passwords
