import { Component, OnInit } from '@angular/core';
import { NoteService } from '../note.service';
import { ActivatedRoute, Router} from '@angular/router';
import { Note } from '../note';

@Component({
  selector: 'app-edit-note',
  templateUrl: './edit-note.component.html',
  styleUrls: ['./edit-note.component.css']
})
export class EditNoteComponent implements OnInit {
  note: Note;

  constructor(private noteService: NoteService, private route:ActivatedRoute) {}

  ngOnInit() {
    this.getNote();
  }

  getNote() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.noteService.getNote(id)
    .subscribe(note => this.note = note)
  }
}
