import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

import { CategoriesComponent } from './categories/categories.component';
import { NotesComponent } from './notes/notes.component';

const routes: Routes = [
  { path: '', redirectTo: '/notes', pathMatch: 'full'},
  { path: 'notes', component: NotesComponent},
  { path: 'categories', component: CategoriesComponent},
]

@NgModule({
  imports: [ RouterModule.forRoot(routes) ],
  exports: [ RouterModule ]
})
export class AppRoutingModule { }
