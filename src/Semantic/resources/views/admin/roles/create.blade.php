@extends('dashboard')

@section('content')

<div class="ui fluid container">
    <div class="ui three column centered grid">
        <div class="row">
            <div class="column">
                <h1>Role Admin: Create</h1>
            </div>
        </div>
        <div class="row">
            <div class="column">
                <form class="ui form" method="POST" action="/admin/roles">
                    {!! csrf_field() !!}

                    <div class="field raw-margin-top-24">
                        @input_maker_label('Name')
                        @input_maker_create('name', ['type' => 'string'])
                    </div>

                    <div class="field raw-margin-top-24">
                        @input_maker_label('Label')
                        @input_maker_create('label', ['type' => 'string'])
                    </div>

                    <div class="field raw-margin-top-24">
                        <a class="ui button violet left" href="{{ URL::previous() }}">Cancel</a>
                        <button class="ui button primary right floated" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop