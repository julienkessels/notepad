import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';

import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { catchError, map, tap } from 'rxjs/operators';

import { Category } from './category';

const httpOptions = {
  headers: new HttpHeaders({ 'Content-Type': 'application/json' })
};

@Injectable()
export class CategoryService {

  private categoriesUrl = 'http://localhost:8000/api';
  categories: Observable<Category[]>;

  constructor(
    private http: HttpClient
  ) { }

  /** GET categories from the server */
  getCategories (): Observable<Category[]> {
    return this.http.get<Category[]>(this.categoriesUrl+'/categories')
      .pipe(
        tap(categories => {}),
        catchError(this.handleError('getCategories', []))
      );
  }

  /** GET category from the server */
  getCategory (id:number): Observable<Category> {
    return this.http.get<Category>(this.categoriesUrl+`/categories/${id}`)
      .pipe(
        tap(_ => console.log('got category')),
        catchError(this.handleError('getCategory'))
      );
  }

  /** POST category to the server */
  addCategory(newCategory: Category): Observable<Category> {
    return this.http.post<Category>(this.categoriesUrl+'/categories', newCategory, httpOptions)
      .pipe(
        tap(_ => console.log('category added')),
        catchError(this.handleError('addCategory'))
      );
  }

  /** PUT category to the server */
  editCategory(editedCategory: Category): Observable<Category> {
    return this.http.put<Category>(this.categoriesUrl+`/categories/${editedCategory.id}`, editedCategory, httpOptions)
      .pipe(
        tap(_ => console.log('category edited')),
        catchError(this.handleError('editcategory'))
      );
  }

  /** DELETE note from the server */
  deleteCategory(category: Category): Observable<any> {
    return this.http.delete<Category>(this.categoriesUrl+`/categories/${category.id}`, httpOptions)
      .pipe(
        tap(_ => this.log('category deleted')),
        catchError(this.handleError('deleteCategory'))
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
      console.error(error); // log to console instead

      // TODO: better job of transforming error for user consumption
      this.log(`${operation} failed: ${error.message}`);

      // Let the app keep running by returning an empty result.
      return of(result as T);
    };
  }

  /** Log a HeroService message with the MessageService */
  private log(message: string) {
    console.log(message)
    //this.messageService.add('HeroService: ' + message);
  }
}
