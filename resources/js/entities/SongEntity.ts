import type { PlaylistEntity, ArtistEntity } from '@/entities'

export interface SongEntity {
    id: number,
    title: string,
    playlist?: Omit<PlaylistEntity, "songs">,
    artist?: Omit<ArtistEntity, "songs">,
    duration: number,
}
