
<table class="table">
    <thead>
        <th>#</th>
        <th>Image</th>
        <th>Details</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Amount</th>
        <th>Action</th>
    </thead>
    <tbody >
    @php
        $ser = 0;
        $amount = 0;
        $total = 0;
    @endphp
    @foreach ($items as $item)
    @php
        $ser += 1;
        $amount = $item->qty * $item->price;
        $total += $amount;
    @endphp
    <tr>
    <td>{{ $ser }}</td>
    <td>
        <a href="{{url($item->product->img)}}" class="defaultGlightbox glightbox-content">
            <img src="{{ $item->product->img}}" style="max-width: 80px;" alt="image" class="img-fluid" />
        </a>
    </td>
    <td> <strong>{{ $item->product->code }}</strong><br>
        {{$item->product->color}}<br>
        {{round($item->product->width,2)}} x {{round($item->product->length,2)}}<br>

    </td>

    <td style="min-width:250px;">
        <div class="input-group">
        <input type="number" id="qty{{ $item->id }}" onfocusout="up_qty({{ $item->id }})" value="{{ $item->qty }}" class="form-control" placeholder="Quantity" aria-label="Quantity" aria-describedby="basic-addon1">
        <span class="input-group-text" id="basic-addon1"> {{ $item->product->unit }}</span>
    </div></td>
    <td style="min-width:200px;"> <input type="number" id="price{{ $item->id }}" onfocusout="up_price({{ $item->id }})" class="form-control" value="{{ $item->price }}"> </td>
    <td>{{ round($amount,2) }}</td>
    <td>
        <svg xmlns="http://www.w3.org/2000/svg" onclick="delete1({{ $item->id }})" class="text-danger" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
    </td>
    </tr>
    @endforeach

</tbody>
<tfoot>
    <tr>
        <td colspan="5" class="text-end"> <strong>Total</strong> </td>
        <td colspan="2"> <strong>{{ round($total,2) }}</strong> </td>
    </tr>
</tfoot>
</table>
