{{--View::composer('include.connect._change_contacts', ChangeContactComposer::class);--}}


{{--<a href="#bid2" data-fancybox="" data-touch="false" class="con_item con_item__1">
    <div class="con_item__left"><span>{{__('Заявка на медиацию')}}</span></div>
    <div class="con_item__right"><div class="con_item__strach"></div></div>

</a>--}}
<a href="#" class="con_item con_item__1 open-fancybox" data-form="record_me">
    <div class="con_item__left"><span>{{__('Заявка на обучение')}}</span></div>
    <div class="con_item__right"><div class="con_item__strach2"></div></div>
</a>


<a href="tel:{{$phone}}" target="_blank" data-type="phone" data-object="{{$phone}}" class="con_item con_item__4 _canche__js">
    <div class="con_item__left"><span>{{__('Позвонить')}}</span></div>
    <div class="con_item__right"><div class="con_item__phone"></div></div>

</a>

<a href="{{$whatsapp}}" target="_blank" data-type="whatsapp" data-object="{{$whatsapp}}" class="con_item con_item__5 _canche__js">
    <div class="con_item__left"><span>{{__('Написать в WhatsApp')}}</span></div>
    <div class="con_item__right"><div class="con_item__whatsapp"></div></div>

</a>

<a href="{{$telegram}}" target="_blank" data-type="telegram" data-object="{{$telegram}}" class="con_item con_item__6 _canche__js">
    <div class="con_item__left"><span>{{__('Написать в Telegram')}}</span></div>
    <div class="con_item__right"><div class="con_item__telegram"></div></div>

</a>
