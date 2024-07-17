<select name="birthplaceRegion" id="select-birthplace-region" class="form-select" required>
    <option value="">Select Region...</option>
    @foreach ($region as $reg)
      <option value="{{ $aes->encrypt($reg->regCode) }}">{{ $reg->regDesc }}</option>
    @endforeach
</select>