<!DOCTYPE html>
<html>
<head>
<style>
 .button {
  background-color: #4CAF50;
  border: none;
  color: #ffffff!important; 
  padding: 7px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 150px;
  border-radius: 2px;
}

#alert{
  color: orange;
}
 
</style>
</head>
<body> 
<img src="{{$message->embed(env('APP_URL').'/imagens/logo.png')}}"> 
<h2>{{$emailSubject->mensagem}}</h2> 
<a href="{{$emailSubject->link}}" class="button">{{$emailSubject->nameBottom}}</a> 
<p id="alert">Este email não recebe mensagens!</p>
</body>
</html>