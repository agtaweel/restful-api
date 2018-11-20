Hello {{$user->name}}
You have changed your email, so we nee to verify this new address. Please use this link :
{{route('verify',$user->verification_token)}}
