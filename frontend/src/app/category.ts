import Note from './note'

export class Category {
  libelle: string = '';
  id: number;
  notes: Note[];

  constructor(values: Object = {}) {
    Object.assign(this, values);
  }
}
