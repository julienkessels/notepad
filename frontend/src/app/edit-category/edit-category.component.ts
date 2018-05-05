import { Component, OnInit } from '@angular/core';
import { Category } from '../category'
import { CategoryService } from '../category.service';
import { ActivatedRoute, Router} from '@angular/router';

@Component({
  selector: 'app-edit-category',
  templateUrl: './edit-category.component.html',
  styleUrls: ['./edit-category.component.css']
})
export class EditCategoryComponent implements OnInit {
  category: Category;

  constructor(private categoryService: CategoryService, private route:ActivatedRoute) {}

  ngOnInit() {
    this.getCategory();
  }

  getCategory() {
    const id = +this.route.snapshot.paramMap.get('id');
    this.categoryService.getCategory(id)
    .subscribe(category => this.category = category)
  }
}
