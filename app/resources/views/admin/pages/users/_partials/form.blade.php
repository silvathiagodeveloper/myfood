@include('admin.includes.alerts')
<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Nome:" value="{{$user->name ?? old('name')}}">
</div>
<div class="form-group">
    <label for="email">Email:</label>
    <input type="text" id="email" name="email" class="form-control" placeholder="Email:" value="{{$user->email ?? old('email')}}">
</div>
<div class="form-group">
    <label for="password">Senha:</label>
    <input type="password" id="password" name="password" class="form-control" placeholder="Senha:">
</div>
<div class="form-group">
    <label for="password_confirmation">Confirma Senha:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Senha:">
</div>
<button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>