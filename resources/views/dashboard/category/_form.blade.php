@csrf
    <label for="title">Título</label>
    <input class="form-control" type="text" name="title" value={{ old('title',$category->title) }}>

    <label for="slug">Slug</label>
    <input class="form-control" type="text" name="slug" value={{ old('slug',$category->slug) }}>


    <button class="mt-4 btn btn-primary" type="submit">Enviar</button>
