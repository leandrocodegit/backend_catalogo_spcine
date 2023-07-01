<!DOCTYPE html>
<html>
<head>
<style>
 .button {
  background-color: #a53684;
  border: none;
  color: #ffffff!important; 
  padding: 4px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
  width: 150px;
  border-radius: 2px;
}

h4{
  color: #727272;
}
#alert{
  color: orange;
}

a:hover{ 
  background: #824ba1!important; 
}
 
</style>
</head>
<body> 
<img src="{{$message->embed(env('APP_URL').'/imagens/logo.png')}}"> 
<h4>{{$emailSubject->mensagem}}</h4> 
<a href="{{$emailSubject->link}}" class="button">{{$emailSubject->nameBottom}}</a> 
<p id="alert">Este email não recebe mensagens!</p>
</body>
</html>