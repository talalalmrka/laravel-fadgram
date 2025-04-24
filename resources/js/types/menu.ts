import { MenuItemType } from "./menu-item"

// types/menu.ts
export interface MenuType {
    value: any
    id: string
    name: string
    position: string
    class_name: string
    items?: MenuItemType[]
}