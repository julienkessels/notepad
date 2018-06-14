import { Component, OnInit, Input } from '@angular/core';
import { Note } from '../note'
import { Category } from '../category'
import { NoteService } from '../note.service';
import { CategoryService } from '../category.service';
import { ActivatedRoute, Router } from "@angular/router";
import { Observable } from 'rxjs/Rx';

@Component({
  selector: 'app-note-form',
  templateUrl: './note-form.component.html',
  styleUrls: ['./note-form.component.css']
})

export class NoteFormComponent implements OnInit {
  note: Note;
  categories: Observable<Category[]>;
  highlight: string;

  @Input('mode') mode: string;

  @Input('passed_note')
  set passed_note(value: Note){
    this.note = value;
  }

  constructor(
    private noteService: NoteService,
    private categoryService: CategoryService,
    private router: Router
  ) {}

  ngOnInit() {
    if(this.passed_note == null) {
      this.note = new Note();
    }
    this.getCategories()
  }

  submit() {
    if(this.mode == "new") {
      this.noteService.addNote(this.note)
      .subscribe(_ => this.router.navigate(["/"]));
    }
    else {
      this.noteService.editNote(this.note)
      .subscribe(_ => this.router.navigate(["/"]));
    }
  }

  onSelect(e) {
      this.highlight = e;
   }

  addTag(event) {
    this.note.content = this.note.content.replace(this.highlight, `<tag>${this.highlight}</tag>`);
  }

  getCategories(): void {
    this.categories = this.categoryService.getCategories()
  }
}
