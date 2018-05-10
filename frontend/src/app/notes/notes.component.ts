import { Component, OnInit } from '@angular/core';
import { NoteService } from '../note.service';
import { CategoryService } from '../category.service';
import { Observable } from 'rxjs/Rx';
import { Note } from '../note'
import {Category} from '../category'
import 'rxjs/add/operator/switchMap';
import 'rxjs/add/operator/map';


@Component({
  selector: 'app-notes',
  templateUrl: './notes.component.html',
  styleUrls: ['./notes.component.css']
})

export class NotesComponent implements OnInit {
  notes: Observable<Note[]>;
  categories: Observable<Category[]>;

  constructor(
    private noteService: NoteService
    private categoryService: CategoryService
  ) {}

  ngOnInit() {
    this.getCategories();
    this.getNotes();
  }

  getNotes(): void {
    this.notes = this.noteService.getNotes()
  }

  getCategories(): void {
    //this.categories = this.categoryService.getCategories()
    //.subscribe(categories => console.log(categories));
  }

  deleteNote(note): void {
    this.noteService.deleteNote(note)
    .subscribe(_ => this.getNotes());
  }
 }
