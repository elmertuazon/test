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

/* Fake image */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
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
<div class="row">
    @foreach ($data as $item)
        <div class="card"> 
        <a href="{{route('posts.show', ['post'=>$item->id])}}"><h2>{{$item->title}}</h2></a>
        <h3>Author {{$item->author}}</h3>
        <h4>Category {{$item->category->name}}</h4>
        <h5>Tags 
          @foreach ($item->tags as $tag)
            {{ucwords($tag->name)}}
          @endforeach
        </h5>
        <h5>Created {{$item->created_at}}</h5>
        <div class="fakeimg" style="height:200px;">Image</div>
        <p>Introduction {{$item->introduction}}</p>
        <p>{{$item->body}}</p>
        </div>
    @endforeach
</div>

{{ $data->links() }}
</body>
</html>
