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
#### Update
```
PUT https://localhost/user/update/id/{id}
{
    <fields to update>
}
```
#### Change Password
```
PUT https://localhost/user/change-password
{
    "password":"password"
}
```
#### Set Roles
```
PUT https://localhost/user/set-roles
{
    "id":"1",
    "roles":[
        "ROLE_USER_ADMIN",
        "ROLE_ANOTHER_READ"
    ]
}
```
#### Delete
```
GET https://localhost/user/delete/{id}
```

-----------------------------------------------------------------

## Recover Password
##### Send
```
POST https://localhost/recover-password/send
{
    // front link where you will have the recover password screen, 
    // where it will be concatenated with the token and sent by email.
    "domain" : "http://front.com/recover-password/token/{here the token will be inserted}
    "username":"email@exemple.com" or "username",
}
```
##### Change
```
PUT https://localhost/recover-password/t/{token}
{
    "password":"new_password",
}
```