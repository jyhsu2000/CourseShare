{{ Html::image(Gravatar::src($user['email'], 40), null, ['class'=>'img-thumbnail']) }}
<span style="font-size: 1.5em">
    {{ link_to_route('user.show', $user['name'], $user['id']) }}
</span>
