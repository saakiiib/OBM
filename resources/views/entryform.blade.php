@csrf
<label>Type<select name="type">@foreach(config('obm.types') as $k=>$label)<option value="{{ $k }}" @selected(old('type',$entry->type??($defaultType??'directory'))===$k)>{{ $label }}</option>@endforeach</select></label>
@foreach(['title','title_bn','country','city','url'] as $field)<label>{{ ucfirst(str_replace('_',' ',$field)) }}<input name="{{ $field }}" value="{{ old($field,$entry->$field??'') }}" @required(in_array($field,['title','url']))></label>@endforeach
<label>Directory category<select name="category"><option value="">Select category (required for directory)</option>
@foreach(\App\Models\Category::orderBy('name')->get() as $cat)
<option value="{{ $cat->name }}" @selected(old('category',$entry->category??'')===$cat->name)>{{ $cat->name }}</option>
@endforeach
</select></label><label>Opportunity category (optional, for non-directory entries)<input name="category_text" value="{{ old('category_text',($entry->type??'directory')!=='directory'?($entry->category??''):'') }}"></label>
<details><summary>Directory contact details (verify before publishing)</summary>
@foreach(['subcategory'=>'Subcategory label','address'=>'Address','phone'=>'Telephone','contact_email'=>'Contact email'] as $field=>$label)
<label>{{ $label }}<input name="{{ $field }}" value="{{ old($field,$entry->details[$field]??'') }}"></label>
@endforeach
</details><label>Summary<textarea name="summary" rows="5">{{ old('summary',$entry->summary??'') }}</textarea></label><p class="small">Pending = hidden awaiting review. Published = publicly visible until expiry. Rejected = hidden. Review the original source before publishing.</p><label>Publication status<select name="status">@foreach(['pending','published','rejected'] as $s)<option @selected(old('status',$entry->status??'pending')===$s)>{{ $s }}</option>@endforeach</select></label>@foreach(['deadline','event_start','expires_at'] as $f)<label>{{ $f }} (UTC)<input type="datetime-local" name="{{ $f }}" value="{{ old($f,isset($entry)&&$entry->$f?$entry->$f->format('Y-m-d\TH:i'):'') }}"></label>@endforeach<button>Save entry and publication status</button>
