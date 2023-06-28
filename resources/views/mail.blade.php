<!DOCTYPE html>
<html>
<head>
<style>
 .button {
  background-color: #4CAF50;
  border: none;
  color: #ffffff!important; 
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  width: 150px;
}
 

</style>
</head>
<body>
 
<h2>Olá {{$user->nome}}, confirme seu email para ativar sua conta.</h2> 
<a href="#" class="button">Confirmar email</a> 

</body>
</html>