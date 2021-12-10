# This is my project php for advanced php lesson

## About configuration :
- There is a config directory where you can modify all the informations about database connection
- Need to set up a vhost systeme 
- The routing systeme is made with the package bramus router
- A MVC design pattern is used here

## How to use it :
- It's an api project, you just need to match the routes in index.php and you will get the results


## API Reference

#### Get all ticket

```http
  GET /tickets
```

#### Get ticket

```http
  GET /ticket/${id}
```

| Parameter | Type      | Description                         |
| :-------- | :-------  | :-----------------------------------|
| `id`      | `integer` | **Required**. Id of ticket to fetch |

#### Create ticket

```http
  POST /tickets
```
need to send a json : 
{\
    "title" : "Ticket name",\
    "section" : "Ticket service",\
    "description" : "Ticket description"\
}

| Parameter | Type      | Description                         |
| :-------- | :-------  | :-----------------------------------|
| `title`      | `string` | **Required**. ticket title |
| `section`      | `string` | **Required**. ticket section |
| `description`      | `string` | **Required**. ticket description |

#### Create ticket file

```http
  GET /ticket/file/{id}
```

To create the file with the ticket you want with all comments 

| Parameter | Type      | Description                         |
| :-------- | :-------  | :-----------------------------------|
| `id`      | `integer` | **Required**. ticket id |


#### Get all comments

```http
  GET /comments
```

#### Get specific comment

```http
  GET /comments/{id}
```

| Parameter | Type      | Description                         |
| :-------- | :-------  | :-----------------------------------|
| `id`      | `integer` | **Required**. ticket id |

#### create comment

```http
  POST /comments/{id}
```
need to send a json : 
{\
    "content" : "comment content",\
}

| Parameter | Type      | Description                         |
| :-------- | :-------  | :-----------------------------------|
| `id`      | `integer` | **Required**. ticket id |