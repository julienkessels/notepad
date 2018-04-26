import { Component, OnInit } from '@angular/core';
import { NoteService } from '../note.service';

@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.css']
})
export class NotesComponent implements OnInit {
  notes: Observable<Note[]>;

  constructor( private noteService: NoteService ) {}

  ngOnInit() {
    this.getNotes();
  }

  getNotes(): void {
    this.noteService.getNotes()
    .subscribe(notes => this.notes = notes)
  }
 }
