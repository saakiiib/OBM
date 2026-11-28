@csrf
<label>Label<input name="label" required maxlength="100" value="{{ $item->label??'' }}"></label><label>Bengali label<input name="label_bn" maxlength="150" value="{{ $item->label_bn??'' }}"></label><label>Destination<select name="destination" required>
@foreach($destinations as $path=>$label)
<option value="{{ $path }}" @selected(($item->destination??'')===$path)>{{ $label }}</option>
@endforeach
</select></label><label>Sort order<input name="sort_order" type="number" min="0" max="10000" required value="{{ $item->sort_order??100 }}"></label><label class="check"><input type="checkbox" name="enabled" value="1" @checked($item->enabled??true)> Enabled</label><button>Save menu item</button>
