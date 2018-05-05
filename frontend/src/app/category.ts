export class Category {
  libelle: string = '';
  id: number;

  constructor(values: Object = {}) {
    Object.assign(this, values);
  }
}
