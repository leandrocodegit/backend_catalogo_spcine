<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<style>
.box-form-reset{
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  width: 100%; 
}
input{
  min-width: 300px!important;
}
p{
  font-weight: 600;
  letter-spacing: 1px;
  font-size: 1.1rem;
}
button{
  width: 300px;
  background: #a53684!important;
  border-radius: 2px!important;
  border: none;
  color: white!important;
}

button:hover{ 
  background: #824ba1!important; 
}

.erros{
  padding: 10px;
}

@media (max-width:600px) {
  input{
  min-width: 250px!important;
}
p{ 
  font-size: 1.0rem;
}
button{
  width: 250px;  
} 
}
</style>
 
 <div class="box-form-reset">
<img src="/imagens/logo.png" alt="logo">
<p>Redefinição de senha.</p> 
<form method="POST" action="/account/reset/password"> 
  @csrf
  <div class="form-group  mt-2">
    <label for="senha">Senha</label>
    <input  onkeyup="comparaSenha()" type="password" class="form-control" id="password" name="password" placeholder="Nova senha">
    <input type="hidden" class="form-control" id="id" name="id" value="{{$id}}">
    <input type="hidden" class="form-control" id="token" name="token" value="{{$token}}">
  </div> 
  
  <div class="form-group mt-3">
    <label for="confirmaSenha">Confirmar senha</label>
    <input  onkeyup="comparaSenha()"type="password" class="form-control" id="confirmaSenha" placeholder="Confirmar senha">
  </div> 
 <p id="alerta"></p>
  <button type="submit" class="btn mt-4">Enviar</button>
</form>

<div class="erros">
@if($errors->any())
  <div class="alert alert-warning">
    <ul>   
  @foreach($errors->all() as $error)
      <li>{{$error}}</li>
      @endforeach
    </ul> 
  </div> 
  @endif
</div>                    
</div>
</body>
</html>

<script>  
function comparaSenha() {  
 
    var password = document.getElementById("password").value; 
  var confirmaSenha = document.getElementById("confirmaSenha").value;   
    if(password.length >= 8  && confirmaSenha.length >= 8) {  
    document.getElementById("alerta").innerHTML = "*1";
    if(password != confirmaSenha) {  
     document.getElementById("alerta").innerHTML = "*Senha são diferentes";    
  }  
}
 
}  
</script>  