<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
  box-sizing: border-box;
}

/* Add a gray background color with some padding */
body {
  font-family: Arial;
  padding: 20px;
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
  padding: 30px;
  font-size: 40px;
  text-align: center;
  background: white;
}

/* Add a card effect for articles */
.card {
   background-color: white;
   padding: 20px;
   margin-top: 20px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
</style>
</head>
<body>

<div class="header">
  <h2>{{$data->title}}</h2>
</div>
<div class="row">
    <div class="card">
        <h3>Author {{$data->author}}</h3>
        <h4>Category {{$data->category->name}}</h4>
        <h5>Tags {{$data->tag}}</h5>
        <h5>Created {{$data->created_at}}</h5>
    </div>
    <div class="card">
        <p>Introduction {{$data->introduction}}</p>
        <p>{{$data->body}}</p>
    </div>
</div>

</body>
</html>