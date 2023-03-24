<style>
    h2{
        color: red
    }
    p{
        font-weight: 400
    }
</style>

<h2 >you have new message to {{$email->lastName}} {{$email->firstName}}</h2>
<h3>Meassge</h3>
<p>
{{$email->message}}
</p>