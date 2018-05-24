import { Component, OnInit } from '@angular/core';
import { CategoryService } from '../category.service';
import {Observable} from 'rxjs/Rx';
import {Category} from '../category'

@Component({
  selector: 'app-categories',
  templateUrl: './categories.component.html',
  styleUrls: ['./categories.component.css']
})
export class CategoriesComponent implements OnInit {
  //categories: Observable<Category[]>;
  categories: Category[];
  constructor( private categoryService: CategoryService ) {}

  ngOnInit() {
    this.getCategories();
  }

  getCategories(): void {
    this.categories = this.categoryService.getCategories()
  }

  deleteCategory(category): void {
    this.categoryService.deleteCategory(category)
    .subscribe(_ => this.getCategories());
  }
}
