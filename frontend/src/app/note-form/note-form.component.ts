import { Component, OnInit, Input } from '@angular/core';
import { Note } from '../note'
import {Category} from '../category'
import { NoteService } from '../note.service';
import { CategoryService } from '../category.service';

import {ActivatedRoute, Router} from "@angular/router";
import {Observable} from 'rxjs/Rx';

@Component({
  selector: 'app-note-form',
  templateUrl: './note-form.component.html',
  styleUrls: ['./note-form.component.css']
})
export class NoteFormComponent implements OnInit {
  note: Note;
  categories: Observable<Category[]>;

  typee: string;

  @Input('mode') mode: string;

  @Input('passed_note')
  set passed_note(value: Note){
    this.note = value;
  }


  constructor(
    private noteService: NoteService,
    private categoryService: CategoryService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit() {
    this.typee = this.mode
    if(this.passed_note == null) {
      this.note = new Note();
    }
    this.getCategories()
  }

  addNote() {
    this.noteService.addNote(this.note)
    .subscribe(_ => this.router.navigate(["/"]));
  }

  getCategories(): void {
    this.categories = this.categoryService.getCategories()
    console.log(this.categories)
  }
}