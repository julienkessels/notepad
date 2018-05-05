import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { NotesComponent } from './notes/notes.component';
import { NewNoteComponent } from './new-note/new-note.component';
import { EditNoteComponent } from './edit-note/edit-note.component';

import { CategoriesComponent } from './categories/categories.component';
import { NewCategoryComponent } from './new-category/new-category.component';
import { EditCategoryComponent } from './edit-category/edit-category.component';

const routes: Routes = [
  { path: '', redirectTo: '/notes', pathMatch: 'full'},
  { path: 'notes', component: NotesComponent},
  { path: 'newNote', component: NewNoteComponent},
  { path: 'editNote/:id', component: EditNoteComponent},
  { path: 'categories', component: CategoriesComponent},
  { path: 'newCategory', component: NewCategoryComponent},
  { path: 'editCategory/:id', component: EditCategoryComponent},

]

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
