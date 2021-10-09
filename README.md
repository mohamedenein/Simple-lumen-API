# Simple lumen API to make a profile for users with Articles
- Build using lumen framework version ^8.*. 
- MySql Database
-  [JSON Web Token (JWT)](https://github.com/tymondesigns/jwt-auth) to handle authentication 

# Documentation 
### User Register Api
Register user by email and phone number and save user name in json `ex:{"en": "ahmed", "ar": "احمد"}`


### login Api
User can login with email or phone number

### User Verification Api
user can verify with email or phone number

### Create/update Article Api
Authenticated user can create article in two languages, title and content saved in json datatype `ex:{"en": "title", "ar": "عنوان"}`

### Delete Article Api 
Authenticated user can delete article by Id

### Profile with articles Api
 Authenticated user can view his profile with articles in selected language
ex endpoint `localhost:8000/api/profile/lang=en`
 
