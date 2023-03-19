@forelse ($items as $myItem)
    <x-comment :item='$myItem'></x-comment>
@empty
    <div class="alert alert-dismissible alert-danger mt-4">
        <h4 class="alert-heading">Not opinions found!</h4>
    </div>
@endforelse