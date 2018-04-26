import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';


import { AppComponent } from './app.component';
import { CategoryService } from './category.service';
import { NoteService } from './note.service';
import { NotesComponent } from './notes/notes.component';
import { CategoriesComponent } from './categories/categories.component';
import { NoteComponent } from './note/note.component';
import { AppRoutingModule } from './/app-routing.module';
import { HttpClientModule } from '@angular/common/http';

@NgModule({
  declarations: [
    AppComponent,
    NotesComponent,
    CategoriesComponent,
    NoteComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule
  ],
  providers: [CategoryService, NoteService],
  bootstrap: [AppComponent]
})
export class AppModule { }
