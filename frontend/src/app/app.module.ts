import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule }   from '@angular/forms';


import { AppComponent } from './app.component';
import { CategoryService } from './category.service';
import { NoteService } from './note.service';
import { NotesComponent } from './notes/notes.component';
import { CategoriesComponent } from './categories/categories.component';
import { AppRoutingModule } from './/app-routing.module';
import { HttpClientModule } from '@angular/common/http';
import { NewNoteComponent } from './new-note/new-note.component';
import { NoteFormComponent } from './note-form/note-form.component';
import { EditNoteComponent } from './edit-note/edit-note.component';
import { CategoryFormComponent } from './category-form/category-form.component';
import { NewCategoryComponent } from './new-category/new-category.component';
import { EditCategoryComponent } from './edit-category/edit-category.component';

@NgModule({
  declarations: [
    AppComponent,
    NotesComponent,
    CategoriesComponent,
    NewNoteComponent,
    NoteFormComponent,
    EditNoteComponent,
    CategoryFormComponent,
    NewCategoryComponent,
    EditCategoryComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    FormsModule
  ],
  providers: [CategoryService, NoteService],
  bootstrap: [AppComponent]
})
export class AppModule { }
