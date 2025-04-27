import { MenuItemType } from "./menu-item"

// types/menu.ts
export interface MenuType {
    id: string
    name: string
    position: string
    class_name: string
    items?: MenuItemType[]
}