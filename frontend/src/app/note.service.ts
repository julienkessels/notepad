import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import { Note } from './note';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class NoteService {

  private notesUrl = 'http://localhost:8000/api';
  notes: Note[] = [];

  constructor(
    private http: HttpClient
  ) { }

  /** GET notes from the server */
  getNotes (): Observable<Note[]> {
    return this.http.get<Note[]>(this.notesUrl+'/notes')
      .pipe(
        tap(_ => console.log('got notes')),
        catchError(this.handleError('getNotes', []))
      );
  }

  /** GET note from the server */
  getNote (id:number): Observable<Note> {
    return this.http.get<Note>(this.notesUrl+`/note/${id}`)
      .pipe(
        tap(_ => console.log('got note')),
        catchError(this.handleError('getNote'))
      );
  }

  /** POST note to the server */
  addNote(newNote: Note): Observable<Note> {
    console.log(newNote)
    return this.http.post<Note>(this.notesUrl+'/note', newNote, httpOptions)
      .pipe(
        tap(_ => console.log('note added')),
        catchError(this.handleError('addNote'))
      );
  }

  /** PUT note to the server */
  editNote(editedNote: Note): Observable<Note> {
    console.log(editedNote)
    return this.http.put<Note>(this.notesUrl+`/note/${editedNote.id}`, editedNote, httpOptions)
      .pipe(
        tap(_ => console.log('note edited')),
        catchError(this.handleError('editnote'))
      );
  }

  /** DELETE note from the server */
  deleteNote(note: Note): Observable<any> {
    return this.http.delete<Note>(this.notesUrl+`/note/${note.id}`, httpOptions)
      .pipe(
        tap(_ => this.log('note deleted')),
        catchError(this.handleError('deleteNote'))
      );
  }

  /**
   * Handle Http operation that failed.
   * Let the app continue.
   * @param operation - name of the operation that failed
   * @param result - optional value to return as the observable result
   */
  private handleError<T> (operation = 'operation', result?: T) {
    return (error: any): Observable<T> => {

      // TODO: send the error to remote logging infrastructure
      this.log(error)

      // TODO: better job of transforming error for user consumption
      this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  /** Log a HeroService message with the MessageService */
  private log(message: string) {
    console.log(message)
  }
}
