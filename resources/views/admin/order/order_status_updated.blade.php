<div class="ol-card p-2">
    <div class="ol-card-body">
        <form action="{{ route('admin.order.timeline_update', ['id' => $id]) }}" method="post">
            @csrf
            
            <div class="input-group mb-3 d-block">
                <label class="form-label ol-form-label mb-2">{{ function_exists('get_phrase') ? get_phrase('Select a status') : 'Select a status' }}</label>
                <select class="form-control ol-select2 w-100" name="order_status_id" id="order_status">
                    <option value="">{{ function_exists('get_phrase') ? get_phrase('Select a status') : 'Select a status' }}</option>
                    {{-- Replaced missing App\Models\Order_status query with the string enums the system uses --}}
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label ol-form-label">{{ function_exists('get_phrase') ? get_phrase('Message') : 'Message' }}</label>
                <input type="text" name="message" class="form-control ol-form-control" placeholder="Type your message here if any...">
            </div>
            
            <div class="input-group mb-5">
                <button type="submit" class="btn ol-btn-primary">{{ function_exists('get_phrase') ? get_phrase('Update') : 'Update' }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    "use strict";

    if (typeof $ !== 'undefined' && $.fn.select2) {
        $('.ol-select2').select2({
            dropdownParent: $("#ajaxModal")
        });
    }
</script>
