@include('admin.includes.alerts')
<div class="form-group">
    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" class="form-control" placeholder="Nome:" value="{{$product->name ?? old('name')}}">
</div>
<div class="form-group">
    <label for="image">Imagem:</label>
    @if(!empty($product->image))
        <img src="{{ url("storage/".($product->image ?? 'blank.jpg')) }}" class="img-size-50"/>
    @endif
    <input type="file" id="image" name="image" class="form-control" placeholder="image:" value="{{$product->image ?? old('image')}}">
</div>
<div class="form-group">
    <label for="price">Preço:</label>
    <input type="text" id="price" name="price" class="form-control" placeholder="Preço:" value="{{$product->price ?? old('price')}}">
</div>
<div class="form-group">
    <label for="description">Descrição:</label>
    <input type="text" id="description" name="description" class="form-control" placeholder="Descrição:" value="{{$product->description ?? old('description')}}">
</div>
<button type="submit" class="btn btn-dark" id="btnSend"><i class="fas fa-save"></i> Enviar</button>