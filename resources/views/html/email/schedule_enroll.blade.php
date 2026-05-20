@extends('html.email.layouts.layout_default_mail')

@section('title', 'Запись на курс')

@section('description', 'Пользователь оставил заявку на запись на курс. Свяжитесь с ним как можно скорее.')

@section('content')
    @foreach($data as $label => $value)
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom:10px;">
            <tr>
                <td style="width:110px; padding:8px 12px 8px 0; vertical-align:top;">
                    <span style="font-family:Arial,Helvetica,sans-serif; font-size:12px; color:#888888; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">{{ $label }}</span>
                </td>
                <td style="padding:8px 0; vertical-align:top; border-bottom:1px solid #eaecf0;">
                    <span style="font-family:Arial,Helvetica,sans-serif; font-size:15px; color:#282828; font-weight:500; word-break:break-word;">{{ $value }}</span>
                </td>
            </tr>
        </table>
    @endforeach
@endsection
