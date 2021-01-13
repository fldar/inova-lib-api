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
POST https://localhost/user/update/id/{id}
{
    <fields to update>
}
```
#### Set Roles
```
POST https://localhost/user/set-roles
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
    "username":"email@exemple.com" or "username",
}
```
##### Change
```
POST https://localhost/recover-password/t/{token}
{
    "password":"new_password",
}
```