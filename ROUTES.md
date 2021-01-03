## Auth
##### Login
```
POST https://localhost/login/
{
    "username":"email@exemple.com" or "username",
    "password":"password"
}
```
##### Logout
```
GET https://localhost/logout/
```

-----------------------------------------------------------------

## User
##### List
```
GET https://localhost/user/list
```
#### Create
```
POST https://localhost/user/create
{
    "name":"Test Name",
    "email":"test@mail.com",
    "username":"test",
    "password":"xab123"
}
```