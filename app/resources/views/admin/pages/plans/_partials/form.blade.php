@include('admin.includes.alerts')
<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Nome:" value="{{$plan->name ?? old('name')}}">
</div>
<div class="form-group">
    <label for="price">Preço:</label>
    <input type="text" id="price" name="price" class="form-control" placeholder="Preço:" value="{{$plan->price ?? old('price')}}">
</div>
<div class="form-group">
    <label for="description">Descrição:</label>
    <input type="text" id="description" name="description" class="form-control" placeholder="Descrição:" value="{{$plan->description ?? old('description')}}">
</div>
<button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>