<div class="row">
    <div class="col-lg-8">
        <div class="form-group">
            {!! Form::label('inputTitle', 'Title:') !!}
            {!! Form::text('title', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <label for="inputBand">Band title:</label>
            <select name="band_id" id="inputBand" class="select2-container form-control">
                @foreach($bands as $band)
                    <option value="{{ $band->id }}"
                        {{ (!empty($post) && $post->band_id == $band->id) ? 'selected' : '' }}>
                        {{ $band->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            {!! Form::label('inputExcerpt', 'Excerpt:') !!}
            {!! Form::textarea('excerpt', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('inputVideo', 'Video link:') !!}
            {!! Form::text('video', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<div class="row">
    <div>
        <input type="submit" value="Save" class="btn btn-block btn-success" >
    </div>
</div>
