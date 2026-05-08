<!-- resources/views/emails/invitation.blade.php -->

<h2>You are invited!</h2>

<p>Hello {{ $invitee->name }},</p>

<p>You have been invited as <b>{{ $invitee->role }}</b>.</p>

<p>
    Click below to accept invitation:
</p>

<a href="{{ url('/accept-invitation/'.$invitee->token) }}">
    Accept Invitation
</a>