@include('admin.includes.alerts')
<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Nome:" value="{{$tenant->name ?? old('name')}}">
</div>
<div class="form-group">
    <label for="logo">Logo:</label>
    @if(!empty($tenant->logo))
        <img src="{{ url("storage/".($tenant->logo ?? 'blank.jpg')) }}" class="img-size-50"/>
    @endif
    <input type="file" id="logo" name="logo" class="form-control" placeholder="logo:" value="{{$tenant->logo ?? old('logo')}}">
</div>
<div class="form-group">
    <label for="cnpj">CNPJ:</label>
    <input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="Preço:" value="{{$tenant->cnpj ?? old('cnpj')}}">
</div>
<button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>