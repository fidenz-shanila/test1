<?php
echo Form::open(array('action' =>'', 'method'=>'post'));
echo Form::label('username','User Name');
echo Form::input('username','');
echo Form::label('password','Password');
echo Form::input('password','',array('type' => 'password'));
echo Form::input('','Submit',array('type' => 'submit'));
echo Form::close();
