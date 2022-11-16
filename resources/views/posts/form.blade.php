<div class="mb-3">
    <label for="title" class="form-label">Title</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" aria-describedby="emailHelp" name="title" value="{{old('title' ,$post->title ?? null)}}">
    @error('title')
        <span class="invalid-feedback"><strong>{{$message}}</strong></span>
    @enderror
  </div>
  <div class="mb-3">
      <label for="content" class="form-label">Content</label>
      <textarea class="form-control @error('content') is-invalid @enderror" id="content" rows="3" name="content" >{{old('content',$post->content ?? null)}}</textarea>
      @error('content')
        <span class="invalid-feedback"><strong>{{$message}}</strong></span>
      @enderror
  </div>