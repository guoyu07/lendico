Lendico Bank API Documentation
============================================

### Examples

Retrieve accounts:
```http
GET /accounts HTTP/1.1
```

Create an account:
```http
POST /accounts/new HTTP/1.1
{
  "number": "123456",
  "client_id": 1
}
```

Another one:
```http
POST /accounts/new HTTP/1.1
{
  "number": "123457",
  "client_id": 2
}
```

Deactivate an account.
```http
PATCH /accounts/{number}/deactivate HTTP/1.1
```
