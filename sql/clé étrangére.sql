ALTER Table Attribution
ADD constraint fk1_Attribution foreign key(idEtab) references Etablissement(id);
ALTER Table Attribution
ADD constraint fk2_Attribution foreign key(idGroupe) references Groupe(id);