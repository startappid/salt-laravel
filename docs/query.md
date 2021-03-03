# Query String
Filter data in your request to API

## Parameters
* fields: `type:array required:false`
* search
* page
* limit
* relationship
* withTrashed
* fieldname[where]
* fieldname[orwhere]
* fieldname[eq]
* fieldname[gt]
* fieldname[gtEq]
* fieldname[lt]
* fieldname[ltEq]
* fieldname[notEq]
* fieldname[like]
* fieldname[contain]
* fieldname[startwith]
* fieldname[endwith]
* fieldname[notlike]
* fieldname[in]
* fieldname[notin]
* fieldname[between]
* fieldname[notbetween]
* fieldname[isnull]
* fieldname[isnotnull]
* fieldname[orderby]

* [ ] AND               (where)     => WHERE and
* [ ] OR                (orwhere)   => WHERE or
* [ ] =                 (eq)        => EQual
* [ ] >                 (gt)        => Greater Than
* [ ] >=                (gtEq)      => Greater Than EQual
* [ ] <                 (lt)        => Less Than
* [ ] <=                (ltEq)      => Less Than EQual
* [ ] !=                (notEq)     => NOT EQual
* [ ] LIKE              (like)      => LIKE
* [ ] LIKE %...%        (contain)   => LIKE %...%
* [ ] LIKE startwith%   (startwith) => LIKE startwith%
* [ ] LIKE %endwith     (endwith)   => LIKE %endwith
* [ ] NOT LIKE          (notlike)   => NOT LIKE
* [ ] IN (...)          (in)        => IN
* [ ] NOT IN (...)      (notin)     => NOT IN
* [ ] BETWEEN           (between)   => BETWEEN
* [ ] NOT BETWEEN       (notbetween)=> NOT BETWEEN
* [ ] IS NULL           (isnull)    => IS NULL
* [ ] IS NOT NULL       (isnotnull) => IS NOT NULL
* [ ] ORDER BY          (orderby)   => ORDER BY
