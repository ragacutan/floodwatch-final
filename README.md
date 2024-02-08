# FLOODWATCH  

## Usage
(Note: You need to clone first the repository using this command in the CMD or terminal "git clone https://github.com/ragacutan/floodwatch-final.git" )  

Step 1: Running the System    
    Clone the git file on htdocs  

    Run SQLYOG and XAMPP.  
    Use this credential to open access the database server  

    Software:sqlYog  
    host:srv443.hstgr.io  
    database:u475920781_flood  
    username:u475920781_flood  
    password:flood4321A  


Step 2: Set Request Type and URL  
    Choose the appropriate HTTP method for this API is (POST) based on the operation you want to perform.  
    Enter the API URL, including the specific endpoint you intend to access (e.g., http://localhost/pawican/public/postName).  

Step 3: Add Headers (if required)  
    If your API request requires specific headers, you can add them in this step.  

Step 4: Add Request Payload
    If you're using a POST or PUT request to add or update data, proceed to the "Body" tab.  
    Select "raw" as the data format, usually using JSON.  
    Enter the JSON payload in the request body.  

Step 5: Send the Request  
    Click the "Send" button to execute the API request.    

Step 6: View the Response  
    Postman will display the API's response in the lower part of the window.  
    You can review the HTTP status code, response headers, and the response body, which typically contains the data returned by the API.  

Step 7: Test Other Endpoints  
    You can repeat the above steps with different endpoints, such as printName, updateName, and deleteName, and customize the payloads as needed for testing various API functionalities.  