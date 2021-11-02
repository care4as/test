@extends('general_layout')
@section('pagetitle')
    IT: Scrum
@endsection
@section('additional_css')
<style>
.entryModal:hover {
    background-color: #e1f4ff !important;
}
.form-control[readonly]{
        cursor: default;
    }
</style>
@endsection
@section('content')

<div>
    <div class="row">
        <div class="col-md-12">
            <div class="max-main-container" style="padding: 10px;">
                <div style="margin-bottom: 10px; display: grid; grid-template-columns: 1fr auto;">
                    <div style="text-align: left; font-weight: 600; font-size: 1.6rem; align-self: center;">
                        Scrum Board
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" style="margin: 0;" data-toggle="modal" data-target="#newEntryModal">Aufgabe erstellen</button>
                    </div>
                </div>
                <div id="scrumGrid" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; text-align: center; grid-gap: 1px; overflow-x: scroll;">
                    <div style="outline: 1px solid black; font-weight: 500; color: white; background-color: #343a40;">Geplant</div>
                    <div style="outline: 1px solid black; font-weight: 500; color: white; background-color: #343a40;">Zugewiesen</div>
                    <div style="outline: 1px solid black; font-weight: 500; color: white; background-color: #343a40;">Bearbeitung</div>
                    <div style="outline: 1px solid black; font-weight: 500; color: white; background-color: #343a40;">Abgeschlossen</div>
                    <div style="outline: 1px solid black; background-color: #e8e8e8;">
                    @if(isset($scrum_entries[1]))
                        @foreach($scrum_entries[1] as $key => $entry)
                            <div class="entryModal" data-toggle="modal" data-target="#EntryModal{{$entry['id']}}" style="background-color: white; margin: 10px; border: 1px solid grey; box-shadow: black 1px 1px; border-radius: 3px; display: grid; grid-template-columns: 8px 1fr">   
                                <div style="border-right: 1px solid gray; @if($entry['priority'] == '1') background-color: green; @elseif($entry['priority'] == '2') background-color: #fd7e14; @elseif($entry['priority'] == '3') background-color: #f54646; @else background-color: black; @endif"></div> <!-- Background Color anpassen -->
                                <div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; width:100%; padding: 10px 5px 0px 5px; text-align: left; font-weight: 600; color: grey; font-size: 0.9rem;">
                                        <div>
                                            ID {{$entry['id']}}
                                        </div>
                                        <div style="text-align: right; font-weight: 500;">
                                            {{$entry['due_date']}}
                                        </div>
                                    </div>
                                    <div style="display: flex; width:100%; padding: 0px 5px; text-align: left; font-weight: 600; font-size: 1.2rem;">
                                        {{$entry['title']}}
                                    </div>
                                    <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1;">
                                        {{$entry['description']}}
                                    </div>
                                </div>                            
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <div style="outline: 1px solid black; background-color: #e8e8e8;">
                    @if(isset($scrum_entries[2]))
                        @foreach($scrum_entries[2] as $key => $entry)
                            <div class="entryModal" data-toggle="modal" data-target="#EntryModal{{$entry['id']}}"  style="background-color: white; margin: 10px; border: 1px solid grey; box-shadow: black 1px 1px; border-radius: 3px; display: grid; grid-template-columns: 8px 1fr">   
                                <div style="border-right: 1px solid gray; @if($entry['priority'] == '1') background-color: green; @elseif($entry['priority'] == '2') background-color: #fd7e14; @elseif($entry['priority'] == '3') background-color: #f54646; @else background-color: black; @endif"></div>
                                <div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; width:100%; padding: 10px 5px 0px 5px; text-align: left; font-weight: 600; color: grey; font-size: 0.9rem;">
                                        <div>
                                            ID {{$entry['id']}}
                                        </div>
                                        <div style="text-align: right; font-weight: 500;">
                                            {{$entry['due_date']}}
                                        </div>
                                    </div>
                                    <div style="display: flex; width:100%; padding: 0px 5px; text-align: left; font-weight: 600; font-size: 1.2rem;">
                                        {{$entry['title']}}
                                    </div>
                                    <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1;">
                                        {{$entry['description']}}
                                    </div>
                                    <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1; color: #fd7e14;">
                                        {{$entry['reviser']}}
                                    </div>
                                </div>                            
                            </div>
                        @endforeach
                    @endif
                    </div>
                    <div style="outline: 1px solid black; background-color: #e8e8e8;">
                    @if(isset($scrum_entries[3]))
                        @foreach($scrum_entries[3] as $key => $entry)
                                <div class="entryModal" data-toggle="modal" data-target="#EntryModal{{$entry['id']}}"  style="background-color: white; margin: 10px; border: 1px solid grey; box-shadow: black 1px 1px; border-radius: 3px; display: grid; grid-template-columns: 8px 1fr">   
                                    <div style="border-right: 1px solid gray; @if($entry['priority'] == '1') background-color: green; @elseif($entry['priority'] == '2') background-color: #fd7e14; @elseif($entry['priority'] == '3') background-color: #f54646; @else background-color: black; @endif"></div>
                                    <div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; width:100%; padding: 10px 5px 0px 5px; text-align: left; font-weight: 600; color: grey; font-size: 0.9rem;">
                                            <div>
                                                ID {{$entry['id']}}
                                            </div>
                                            <div style="text-align: right; font-weight: 500;">
                                                {{$entry['due_date']}}
                                            </div>
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px; text-align: left; font-weight: 600; font-size: 1.2rem;">
                                            {{$entry['title']}}
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1;">
                                            {{$entry['description']}}
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1; color: #fd7e14;">
                                            {{$entry['reviser']}}
                                        </div>
                                    </div>                            
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div style="outline: 1px solid black; background-color: #e8e8e8;">
                    @if(isset($scrum_entries[4]))
                        @foreach($scrum_entries[4] as $key => $entry)
                                <div class="entryModal" data-toggle="modal" data-target="#EntryModal{{$entry['id']}}"  style="background-color: white; margin: 10px; border: 1px solid grey; box-shadow: black 1px 1px; border-radius: 3px; display: grid; grid-template-columns: 8px 1fr">   
                                    <div style="border-right: 1px solid gray; @if($entry['priority'] == '1') background-color: green; @elseif($entry['priority'] == '2') background-color: #fd7e14; @elseif($entry['priority'] == '3') background-color: #f54646; @else background-color: black; @endif"></div>
                                    <div>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; width:100%; padding: 10px 5px 0px 5px; text-align: left; font-weight: 600; color: grey; font-size: 0.9rem;">
                                            <div>
                                                ID {{$entry['id']}}
                                            </div>
                                            <div style="text-align: right; font-weight: 500;">
                                                {{$entry['due_date']}}
                                            </div>
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px; text-align: left; font-weight: 600; font-size: 1.2rem;">
                                            {{$entry['title']}}
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1;">
                                            {{$entry['description']}}
                                        </div>
                                        <div style="display: flex; width:100%; padding: 0px 5px 10px 5px; text-align: left; font-size: 1rem; line-height: 1; color: #fd7e14;">
                                            {{$entry['reviser']}}
                                        </div>
                                    </div>                            
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>
@endsection

@section('additional_modal')
<div class="modal fade" id="newEntryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="z-index: 500000;">
        <div class="modal-content">
            <form action="{{route('scrum.add')}}" method="post()">
            @csrf
                <div class="modal-header ">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Aufgabe erstellen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="font-size: 14px;">
                    <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 25px; grid-row-gap: 5px;">
                        <label for="status" style="margin: auto auto auto 0; font-weight: 600;">Status:</label>
                        <select id="status" class="form-control" name="status" style="color:black;">
                            <option value="1" selected>Geplant</option>
                            <option value="2">Zugewiesen</option>
                            <option value="3">Bearbeitung</option>
                            <option value="4">Abgeschlossen</option>
                        </select>
                        <label for="priority" style="margin: auto auto auto 0; font-weight: 600;">Priorität:</label>
                        <select id="priority" class="form-control" name="priority" style="color:black;">
                            <option value="1" selected>Niedrig</option>
                            <option value="2">Mittel</option>
                            <option value="3">Hoch</option>
                        </select>
                        <label for="due_date" style="margin: auto auto auto 0; font-weight: 600;">Fertigstellung:</label>
                        <input type="date" id="dateTo" name="due_date" class="form-control" placeholder="" style="color: black;">
                        <label for="reviser" style="margin: auto auto auto 0; font-weight: 600;">Bearbeiter:</label>
                        <input type="text" class="form-control" id="reviser" name="reviser">
                        <label for="title" style="margin: auto auto auto 0; font-weight: 600;">Titel:</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <label for="description" style="margin: auto auto auto 0; font-weight: 600;">Beschreibung:</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>    
                <div class="modal-footer" style="font-size: 14px;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if(isset($scrum_entries))
    @foreach($scrum_entries as $key => $row)
        @foreach($row as $innerarray => $entry)
        <div class="modal fade" id="EntryModal{{$entry['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="z-index: 500000;">
                <div class="modal-content">
                    <form action="{{route('scrum.update')}}" method="post()">
                    @csrf
                        <div class="modal-header ">
                            <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Aufgabe erstellen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="font-size: 14px;">
                            <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 25px; grid-row-gap: 5px;">
                                <label for="id" style="margin: auto auto auto 0; font-weight: 600;">ID:</label>
                                <input type="id" class="form-control" id="id" name="id" value="{{$entry['id']}}" readonly>
                                <label for="status" style="margin: auto auto auto 0; font-weight: 600;">Status:</label>
                                <select id="status" class="form-control" name="status" style="color:black;">
                                    @if($entry['status'] == '1')
                                        <option value="1" selected>Geplant</option>
                                    @else
                                        <option value="1">Geplant</option>
                                    @endif
                                    @if($entry['status'] == '2')
                                        <option value="2" selected>Zugewiesen</option>
                                    @else
                                        <option value="2">Zugewiesen</option>
                                    @endif
                                    @if($entry['status'] == '3')
                                        <option value="3" selected>Bearbeitung</option>
                                    @else
                                        <option value="3">Bearbeitung</option>
                                    @endif
                                    @if($entry['status'] == '4')
                                        <option value="4" selected>Abgeschlossen</option>
                                    @else
                                        <option value="4">Abgeschlossen</option>
                                    @endif
                                </select>
                                <label for="priority" style="margin: auto auto auto 0; font-weight: 600;">Priorität:</label>
                                <select id="priority" class="form-control" name="priority" style="color:black;">
                                    @if($entry['priority'] == '1')
                                        <option value="1" selected>Niedrig</option>
                                    @else
                                        <option value="1">Niedrig</option>
                                    @endif
                                    @if($entry['priority'] == '2')
                                        <option value="2" selected>Mittel</option>
                                    @else
                                        <option value="2">Mittel</option>
                                    @endif
                                    @if($entry['priority'] == '3')
                                        <option value="3" selected>Hoch</option>
                                    @else
                                        <option value="3">Hoch</option>
                                    @endif
                                </select>
                                <label for="due_date" style="margin: auto auto auto 0; font-weight: 600;">Fertigstellung:</label>
                                <input type="date" id="dateTo" name="due_date" class="form-control" style="color: black;" value="{{$entry['due_date']}}">
                                <label for="reviser" style="margin: auto auto auto 0; font-weight: 600;">Bearbeiter:</label>
                                <input type="text" class="form-control" id="reviser" name="reviser" value="{{$entry['reviser']}}">
                                <label for="title" style="margin: auto auto auto 0; font-weight: 600;">Titel:</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$entry['title']}}">
                                <label for="description" style="margin: auto auto auto 0; font-weight: 600;">Beschreibung:</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{$entry['description']}}</textarea>
                            </div>
                        </div>    
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="button" class="btn btn-danger" style="margin-right: auto;" data-dismiss="modal" data-toggle="modal" data-target="#DeleteModal{{$entry['id']}}">Löschen</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" >Schließen</button>
                            <button type="submit" class="btn btn-primary">Speichern</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="DeleteModal{{$entry['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document" style="z-index: 500000;">
                <div class="modal-content">
                    <form action="{{route('scrum.delete')}}" method="post()">
                    @csrf
                        <div class="modal-header ">
                            <h5 class="modal-title" id="exampleModalLabel" style="font-size: 1.45em;">Eintrag löschen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="font-size: 14px;">
                            <div style="margin-bottom: 5px;">Soll der ausgewählte Eintrag unwiederbringlich gelöscht werden?</div>
                            <div style="display: grid; grid-template-columns: auto 1fr; column-gap: 25px; grid-row-gap: 5px;">
                                <label for="id" style="margin: auto auto auto 0; font-weight: 600;">ID:</label>
                                <input type="id" class="form-control" id="id" name="id" value="{{$entry['id']}}" readonly>
                            </div>
                        </div>    
                        <div class="modal-footer" style="font-size: 14px;">
                            <button type="submit" class="btn btn-danger" style="margin-right: auto;">Löschen</button>
                            <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#EntryModal{{$entry['id']}}">Abbrechen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
@endif

@endsection