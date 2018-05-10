import { Component, OnInit, Input } from '@angular/core';
import { Category } from '../category'
import { CategoryService } from '../category.service';
import {ActivatedRoute, Router} from "@angular/router";

@Component({
  selector: 'app-category-form',
  templateUrl: './category-form.component.html',
  styleUrls: ['./category-form.component.css']
})
export class CategoryFormComponent implements OnInit {
  category: Category;

  @Input('mode') mode: string;

  @Input('passed_category')
  set passed_category(value: Category){
    this.category = value;
  }


  constructor(
    private categoryService: CategoryService,
    private route: ActivatedRoute,
    private router: Router
  ) {}

  ngOnInit() {
    if(this.passed_category == null) {
      this.category = new Category();
    }
  }

  submit() {
    if(this.mode == 'new') {
      this.categoryService.addCategory(this.category)
      .subscribe(_ => this.router.navigate(["categories"]));
    }
    else {
      this.categoryService.editCategory(this.category)
      .subscribe(_ => this.router.navigate(["categories"]));
    }
  }
  }
