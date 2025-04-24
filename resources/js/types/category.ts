// types/category.ts
export interface CategoryType {
    id: string
    name: string
    children?: CategoryType[]
}